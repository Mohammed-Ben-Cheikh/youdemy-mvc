let tags = new Set();
const maxChars = 200;

// Charger les tags existants au chargement de la page
document.addEventListener("DOMContentLoaded", () => {
    loadExistingTags();
    setupEventListeners();
});

function setupEventListeners() {
    const tagsInput = document.getElementById("tags-input");
    const charLimitMsg = document.getElementById("char-limit-msg");

    tagsInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && tagsInput.value.trim() !== "") {
            e.preventDefault();
            addSingleTag(tagsInput.value.trim());
            tagsInput.value = "";
        }
    });

    tagsInput.addEventListener("input", () => {
        charLimitMsg.classList.toggle("hidden", tagsInput.value.length <= maxChars);
    });
}

async function loadExistingTags() {
    try {
        const response = await fetch('../../../app/action/admin/tag/TagApiHandler.php?action=get_tags');
        const data = await response.json();

        if (data.success && Array.isArray(data.data)) {
            tags = new Set(data.data);  // Convert the array of tags to a Set
            console.log(tags);           // Logs the Set object
            updateTagsDisplay();         // Update the display with the tags
        } else {
            showMessage("Aucune donnée de tags disponible", "warning");
        }
    } catch (error) {
        showMessage("Erreur lors du chargement des tags", "error");
    }
}

function addSingleTag(tagValue) {
    let splitTagss = tagValue.split(',');
    splitTagss.map(tag => {
        splitTags(tag);
    });
    async function splitTags(tagValue) {
        const tag = tagValue.replace(/\s+/g, "_");
        if (tag.length <= maxChars && !tags.has(tag)) {
            try {
                const response = await fetch('../../../app/action/admin/tag/TagApiHandler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=add_tag&tag=${encodeURIComponent(tag)}`
                });

                const data = await response.json();

                if (data.success) {
                    tags.add(tag);
                    updateTagsDisplay();
                    showMessage("Tag ajouté avec succès", "success");
                } else {
                    showMessage(data.message || "Erreur lors de l'ajout du tag", "error");
                }
            } catch (error) {
                showMessage("Erreur lors de l'ajout du tag", "error");
            }
        }
    }
}

async function removeTag(tag) {
    try {
        const response = await fetch('../../../app/action/admin/tag/TagApiHandler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=remove_tag&tag=${encodeURIComponent(tag)}`
        });

        const data = await response.json();

        if (data.success) {
            tags.delete(tag);
            updateTagsDisplay();
            showMessage("Tag supprimé avec succès", "success");
        } else {
            showMessage(data.message || "Erreur lors de la suppression du tag", "error");
        }
    } catch (error) {
        showMessage("Erreur lors de la suppression du tag", "error");
    }
}

function updateTagsDisplay() {
    const tagsContainer = document.getElementById("tags-container");

    tagsContainer.innerHTML = Array.from(tags).map(tag => `
                <span class="flex items-center gap-2 bg-gradient-to-r from-blue-100 to-blue-300 text-blue-700 px-3 py-1 rounded-full shadow-sm hover:shadow-md transition">
                    <span class="font-bold">#${tag}</span>
                    <button type="button" 
                            onclick="removeTag('${tag}')"
                            class="text-red-500 hover:text-red-700 transition text-xl font-bold font-serif">
                            ¤
                    </button>
                </span>
            `).join("");
}

function showMessage(message, type) {
    const messageDiv = document.getElementById("message");
    messageDiv.textContent = message;
    messageDiv.className = `mb-4 p-4 rounded-lg ${type === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'}`;

    setTimeout(() => {
        messageDiv.className = 'rounded-lg h-16 m-1';
        messageDiv.textContent = '';
    }, 3000);
}

function handleSubmit(event) {
    event.preventDefault();
    const tagsInput = document.getElementById("tags-input");

    if (tagsInput.value.trim()) {
        addSingleTag(tagsInput.value.trim());
        tagsInput.value = "";
    }
}

function openAddTagModal() {
    const modal = document.getElementById('addTagModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAddTagModal() {
    const modal = document.getElementById('addTagModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
    document.getElementById("tags-input").value = "";
    document.getElementById("char-limit-msg").classList.add("hidden");
}

function openAddModal() {
    document.getElementById('addCategoryModal').classList.remove('hidden');
    document.getElementById('addCategoryModal').classList.add('flex');
}

function closeAddModal() {
    const modal = document.getElementById('addCategoryModal');
    modal.classList.add('hidden');
    document.getElementById('addCategoryForm').reset();
    document.getElementById('imagePreview').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('addCategoryModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeAddModal();
    }
});

function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function () {
        preview.querySelector('img').src = reader.result;
        preview.classList.remove('hidden');
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}

function handleSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('#submitBtn');
    const spinner = form.querySelector('#loadingSpinner');

    // Show loading state
    submitBtn.disabled = true;
    spinner.classList.remove('hidden');

    fetch('../../../app/action/admin/categorie/add_category.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            alert('Erreur: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            spinner.classList.add('hidden');
        });
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const preview = document.getElementById('imagePreview');
    const previewImg = preview.querySelector('img');

    if (file) {
        // Show file name
        fileName.textContent = file.name;
        fileInfo.classList.remove('hidden');

        // Preview image
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function handleFileSelectEdit(event) {
    const file = event.target.files[0];
    const fileInfo = document.getElementById('fileInfoEdit');
    const fileName = document.getElementById('fileNameEdit');
    const preview = document.getElementById('currentImage');
    const previewImg = preview.querySelector('img');

    if (file) {
        // Show file name
        fileName.textContent = file.name;
        fileInfo.classList.remove('hidden');

        // Preview image
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Add drag and drop support
const dropZone = document.querySelector('label[for="categoryImage"]');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropZone.classList.add('border-purple-500', 'bg-gray-700');
}

function unhighlight(e) {
    dropZone.classList.remove('border-purple-500', 'bg-gray-700');
}

dropZone.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const file = dt.files[0];
    const fileInput = document.getElementById('categoryImage');

    fileInput.files = dt.files;
    handleFileSelect({ target: { files: [file] } });
}

function deleteCategory(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
        const formData = new FormData();
        formData.append('id', id);

        fetch('../../../app/action/admin/categorie/delete_category.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                alert('Erreur: ' + error.message);
            });
    }
}

// Add these new functions
function editCategory(categoryId) {
    // Show modal
    const modal = document.getElementById('editCategoryModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // Fetch category data
    fetch(`../../../app/action/admin/categorie/get_category.php?id=${categoryId}`)
        .then(response => response.json())
        .then(category => {
            document.getElementById('editCategoryId').value = category.id_categorie;
            document.getElementById('editCategoryName').value = category.nom;
            document.getElementById('editCategoryDesc').value = category.description;

            // Show current image if exists
            const currentImage = document.querySelector('#currentImage img');
            if (currentImage && category.image_url) {
                currentImage.src = '../../../app/action/admin/' + category.image_url;
                currentImage.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading category data');
        });
}

function closeEditModal() {
    const modal = document.getElementById('editCategoryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('editCategoryForm').reset();
    const currentImage = document.querySelector('#currentImage img');
    if (currentImage) {
        currentImage.classList.add('hidden');
    }
}

function handleEditSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('#submitEditBtn');
    const spinner = form.querySelector('#loadingEditSpinner');
    // Show loading state
    submitBtn.disabled = true;
    spinner.classList.remove('hidden');

    fetch('../../../app/action/admin/categorie/update_category.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeEditModal();
                window.location.reload();
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            alert('Erreur: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            spinner.classList.add('hidden');
        });
}

// Close modal when clicking outside
document.getElementById('editCategoryModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeEditModal();
    }
});