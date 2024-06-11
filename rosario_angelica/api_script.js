document.addEventListener('DOMContentLoaded', () => {
    const apiUrl = './api.php'; 
    const teamTable = document.getElementById('team-table')
        .getElementsByTagName('tbody')[0];
    const createForm = document.getElementById('create-form');

    const fetchTeams = async () => {
        const response = await fetch(apiUrl);
        const teams = await response.json();
        teamTable.innerHTML = '';
        teams.forEach(team => {
            const row = teamTable.insertRow();
            row.innerHTML = `
                <td>${team.id}</td>
                <td>${team.v_team}</td>
                <td>${team.v_coach}</td>
                <td>${team.v_players}</td>
                <td>${team.position}</td>
                <td>${team.championship}</td>
                <td>
                    <button onclick="editTeam(${team.id})">Edit</button>
                    <button onclick="deleteTeam(${team.id})">Delete</button>
                </td>
            `;
        });
    };

    createForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = {
            v_team: document.getElementById('v_team').value,
            v_coach: document.getElementById('v_coach').value,
            v_players: document.getElementById('v_players').value,
            position: document.getElementById('position').value,
            championship: document.getElementById('championship').value
        };
        await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });
        fetchTeams();
        createForm.reset();
    });

    window.deleteTeam = async (id) => {
        if (confirm('Are you sure you want to delete this team?')) {
            await fetch(`${apiUrl}?id=${id}`, { method: 'DELETE' });
            fetchTeams();
        }
    };

    fetchTeams();
});
