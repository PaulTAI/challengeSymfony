let infosUser = document.querySelectorAll(".infos-users")

for (let infos of infosUser) {
	infos.addEventListener('click', function () {
		document.querySelector("#infos-user-title").innerHTML = `${this.dataset.firstname} ${this.dataset.lastname}`
		document.querySelector("#infos-user-body").innerHTML = `	<ul class="list-group col-10">
		<li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="badge bg-success">email</span>
            <div>${this.dataset.email}</div>
		</li>
		<li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="badge bg-secondary">documents</span>
            <div>${this.dataset.documents}</div>
		</li>
	</ul>`
	})
}

let upgradeToAdmin = document.querySelectorAll(".upgrade-admin")

for (let confirm of upgradeToAdmin) {
    confirm.addEventListener('click', function () {
        document.querySelector("#upgrade-user-footer a").href = `/makeAdmin/${this.dataset.id}`
        document.querySelector("#upgrade-user-body").innerHTML = `<p>Vous êtes sur le point de donner le role <b>ADMINISTRATEUR</b> à l'utilisateur <b>${this.dataset.firstname} ${this.dataset.lastname}</b>.</p>
        <p><b>${this.dataset.firstname} ${this.dataset.lastname}</b> aura les mêmes pouvoirs que vous !</p>
        <p>En êtes vous sûr ?</p>`
    })
}

let deleteBooster = document.querySelectorAll(".delete-user")

for (let confirm of deleteBooster) {
    confirm.addEventListener('click', function () {
        document.querySelector("#delete-user-body").innerHTML = `<p>Etes vous sûr de vouloir supprimer l'utilisateur <b>${this.dataset.firstname} ${this.dataset.lastname}</b> ?</p>`
        document.querySelector("#delete-user-title").innerHTML = `Supprimer ${this.dataset.firstname} ${this.dataset.lastname}`
        document.querySelector("#delete-user-footer a").href = `/deleteUser/${this.dataset.id}`
    })
}