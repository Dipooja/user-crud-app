const form = document.getElementById('userForm');
const tableBody = document.querySelector('#userTable tbody');

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const user = {
    name: form.name.value,
    email: form.email.value,
    password: form.password.value,
    dob: form.dob.value
  };

  fetch('http://localhost/user_api_project/config/user/create.php', {
  method: 'POST',
  headers: {'Content-Type': 'application/json'},
  body: JSON.stringify(user)
});

  form.reset();
  loadUsers();
});

async function loadUsers() {
  const res = await fetch("http://localhost/user_api_project/config/user/read.php");
  const users = await res.json();
  tableBody.innerHTML = '';
  users.forEach(user => {
    tableBody.innerHTML += `<tr>
      <td>${user.id}</td><td>${user.name}</td><td>${user.email}</td><td>${user.dob}</td>  <td>
                        <button class="btn btn-sm btn-primary" onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.dob}')">Update</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">Delete</button>
                    </td>
    </tr>`;
  });
}

loadUsers();





function deleteUser(id) {
    if (confirm("Are you sure you want to delete this user?")) {
        fetch(`http://localhost/user_api_project/config/user/delete.php?id=${id}`, {
            method: "DELETE"
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message);
            fetchUsers(); // Refresh the user list
        })
        .catch(error => {
            console.error("Delete error:", error);
        });
    }
}

function editUser(id, name, email, dob) {
    document.getElementById("userId").value = id;
    document.getElementById("name").value = name;
    document.getElementById("email").value = email;
    document.getElementById("dob").value = dob;

    document.getElementById("submitBtn").innerText = "Update User";
}
