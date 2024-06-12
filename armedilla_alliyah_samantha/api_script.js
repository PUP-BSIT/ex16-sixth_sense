document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('groupForm');
    const table = document.getElementById('groupsTable').getElementsByTagName('tbody')[0];

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        const id = formData.get('id');
        
        if (id) {
            // Update existing record
            fetch(`api.php?id=${id}`, {
                method: 'PUT',
                body: new URLSearchParams(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert('Group updated successfully');
                    loadGroups();
                    form.reset();
                }
            });
        } else {
            // Create new record
            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert('Group created successfully');
                    loadGroups();
                    form.reset();
                }
            });
        }
    });

    table.addEventListener('click', function(event) {
        if (event.target.classList.contains('edit')) {
            const id = event.target.dataset.id;
            fetch(`api.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    for (const key in data) {
                        if (form.elements[key]) {
                            form.elements[key].value = data[key];
                        }
                    }
                });
        } else if (event.target.classList.contains('delete')) {
            const id = event.target.dataset.id;
            if (confirm('Are you sure you want to delete this group?')) {
                fetch(`api.php?id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert('Group deleted successfully');
                        loadGroups();
                    }
                });
            }
        }
    });

    function loadGroups() {
        fetch('api.php')
            .then(response => response.json())
            .then(data => {
                table.innerHTML = '';
                data.forEach(group => {
                    const row = table.insertRow();
                    row.innerHTML = `
                        <td>${group.id}</td>
                        <td>${group.group_name}</td>
                        <td>${group.number_of_members}</td>
                        <td>${group.Leader}</td>
                        <td>${group.song}</td>
                        <td>${group.company_name}</td>
                        <td>
                            <button class="edit" data-id="${group.id}">Edit</button>
                            <button class="delete" data-id="${group.id}">Delete</button>
                        </td>
                    `;
                });
            });
    }

    loadGroups();
});