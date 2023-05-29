//  10)
function dispatchError(error) { 
    console.log("Errore");
}



//  9)
function databaseResponse(json) {
    if (!json.ok) {
        dispatchError();
        return null;
    }

}



//  8)
function dispatchResponse(response) {
    console.log(response);
    return response.json().then(databaseResponse); 
}



//  3)
function reset(){
    const element = document.querySelector(".selected");
    element.remove();
}



//  5)
function unsaveBook(event){
    console.log("Rimuovo dalla libreria...");
    const like = event.currentTarget;
    like.classList.remove("liked");
    like.src = "black_heart.png";
    // Preparo i dati da mandare al server e invio la richiesta con POST
    const book = event.currentTarget.parentNode;
    book.classList.add("selected");
    const formData = new FormData();
    formData.append('isbn', book.dataset.isbn);
    formData.append('title', book.dataset.title);
    formData.append('author', book.dataset.author);
    formData.append('cover', book.dataset.cover);
    fetch("unsave_books.php", {method: 'post', body: formData}).then(dispatchResponse, dispatchError);
    event.stopPropagation();
    reset();
    location.reload();
  }



//  4)
function fetchBooksJson(json) {
    console.log("Cerco tra i preferiti...");
    console.log(json);
    const library = document.querySelector('#book-grid');
    if(json.length == 0){
        const trash = document.getElementById("trash");
        trash.classList.add("hidden");
        const msg = document.createElement("h3");
        msg.classList.add("msg");
        msg.textContent = "Nessun libro è stato aggiunto" + "\n" + ":(";
        library.appendChild(msg);
    }
    else{
        const title_tot = document.getElementById("tot");
        title_tot.textContent = "LIBRI PREFERITI: " + json.length;
        for(let book in json){
            const b = document.createElement('div');
            b.dataset.isbn = json[book].isbn;
            b.classList.add("book");
            const img = document.createElement("img");
            img.classList.add("cover");
            img.src = json[book].cover;
            const title = document.createElement("span");
            title.textContent = json[book].title;
            title.classList.add("title");
            const like = document.createElement("img");
            like.classList.add("liked");
            like.src = "red_heart.png";
            like.addEventListener("click", unsaveBook);
            b.appendChild(img);
            b.appendChild(title);
            b.appendChild(like);
            library.appendChild(b);
        }   
    }
}



//  3)
function fetchResponse(response) {
    return response.json();
}



//  2)
function fetchBooks() {
    fetch("fetch_book.php").then(fetchResponse).then(fetchBooksJson);
}

//  1)
fetchBooks();
