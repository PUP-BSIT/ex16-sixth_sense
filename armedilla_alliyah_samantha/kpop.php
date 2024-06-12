<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPOP CRUD Application</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <h1>KPOP</h1>
    <form id="group_Form">
        <input type="hidden" id="id" name="id">
        <label for="group_name">Group Name:</label>
        <input type="text" id="group_name" name="group_name"><br>
        <label for="number_of_members">Number of Members:</label>
        <input type="number" id="number_of_members" name="number_of_members"><br>
        <label for="Leader">Leader:</label>
        <input type="text" id="Leader" name="Leader"><br>
        <label for="song">Song:</label>
        <input type="text" id="song" name="song"><br>
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name"><br>
        <button type="submit">Save</button>
    </form>

    <h2>Groups List</h2>
    <table id="groups_Table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Group Name</th>
                <th>Number of Members</th>
                <th>Leader</th>
                <th>Song</th>
                <th>Company Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script src="api_script.js"></script>
</body>
</html>