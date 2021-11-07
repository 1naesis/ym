if (document.getElementById("search-btn")) {
    document.getElementById("search-btn").addEventListener('click', el => {
        let searchInput = document.getElementById("search-input");
        let searchUrl = "/friends?find="+searchInput.value;
        location.href = searchUrl;
    })
}

function removeFriend(uuid) {
    confirm("Удалить "+uuid);
}
function addFriend(uuid){
    confirm("Добавить "+uuid);
}