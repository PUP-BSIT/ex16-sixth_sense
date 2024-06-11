const apiUrl = "https://memoirverse.site/gasta_backend";

document.addEventListener('DOMContentLoaded', () => {
    fetchTeams();

    document.getElementById('createButton').addEventListener('click', async () => {
        const teamData = getFormData();
        await createTeam(teamData);
        fetchTeams();
        clearForm();
    });

    document.getElementById('updateButton').addEventListener('click', async () => {
        const id = document.getElementById('id').value;
        const teamData = getFormData();
        await updateTeam(id, teamData);
        fetchTeams();
        clearForm();
    });

    document.getElementById('deleteButton').addEventListener('click', async () => {
        const id = document.getElementById('id').value;
        await deleteTeam(id);
        fetchTeams();
        clearForm();
    });
});

async function fetchTeams() {
    try {
        const response = await fetch(`${apiUrl}/read.php`);
        if (response.ok) {
            const teams = await response.json();
            renderTeams(teams);
        } else {
            console.error('Failed to fetch teams from the API');
        }
    } catch (error) {
        console.error('Failed to fetch teams:', error);
    }
}

async function createTeam(teamData) {
    try {
        const response = await fetch(`${apiUrl}/create.php`, {
            method: 'POST',
            body: JSON.stringify(teamData),
            headers: {
                'Content-Type': 'application/json'
            }
        });
        if (response.ok) {
            const result = await response.json();
            console.log(result);
        } else {
            console.error('Failed to create team');
        }
    } catch (error) {
        console.error('Error creating team:', error);
    }
}

async function updateTeam(id, teamData) {
    try {
        const response = await fetch(`${apiUrl}/update.php`, {
            method: 'PUT',
            body: JSON.stringify({ id, ...teamData }),
            headers: {
                'Content-Type': 'application/json'
            }
        });
        if (response.ok) {
            const result = await response.json();
            console.log(result);
        } else {
            console.error('Failed to update team');
        }
    } catch (error) {
        console.error('Error updating team:', error);
    }
}

async function deleteTeam(id) {
    try {
        const response = await fetch(`${apiUrl}/delete.php`, {
            method: 'DELETE',
            body: JSON.stringify({ id }),
            headers: {
                'Content-Type': 'application/json'
            }
        });
        if (response.ok) {
            const result = await response.json();
            console.log(result);
        } else {
            console.error('Failed to delete team');
        }
    } catch (error) {
        console.error('Error deleting team:', error);
    }
}

function getFormData() {
    return {
        team_name: document.getElementById('team_name').value,
        championship: document.getElementById('championship').value,
        Conference: document.getElementById('Conference').value,
        player_name: document.getElementById('player_name').value,
        city: document.getElementById('city').value
    };
}

function renderTeams(teams) {
    const teamsList = document.getElementById('teamsList');
    teamsList.innerHTML = '';
    teams.forEach(team => {
        const li = document.createElement('li');
        li.textContent = `${team.team_name} (${team.city}) - ${team.player_name}`;
        li.addEventListener('click', () => {
            document.getElementById('id').value = team.id;
            document.getElementById('team_name').value = team.team_name;
            document.getElementById('championship').value = team.championship;
            document.getElementById('Conference').value = team.Conference;
            document.getElementById('player_name').value = team.player_name;
            document.getElementById('city').value = team.city;
        });
        teamsList.appendChild(li);
    });
}

function clearForm() {
    document.getElementById('id').value = '';
    document.getElementById('team_name').value = '';
    document.getElementById('championship').value = '';
    document.getElementById('Conference').value = '';
    document.getElementById('player_name').value = '';
    document.getElementById('city').value = '';
}