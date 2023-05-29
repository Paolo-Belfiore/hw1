

//  11)
function dispatchError(error) { 
    console.log("Errore");
}



//  12)
function databaseResponse(json) {
    if (!json.ok) {
        dispatchError();
        return null;
    }
}



//  10)
function dispatchResponse(response) {
    console.log(response);
    return response.json().then(databaseResponse); 
}



//  9)
function unsaveBook(event){
    console.log("Rimuovo dalla libreria...");
    const like = event.currentTarget;
    like.src = "black_heart.png";
    // Preparo i dati da mandare al server e invio la richiesta con POST
    const book = event.currentTarget.parentNode;
    book.classList.remove("favourite");
    const cover = book.querySelector(".cover");
    cover.classList.remove("favourite");
    const formData = new FormData();
    formData.append('isbn', book.dataset.isbn);
    formData.append('title', book.dataset.title);
    formData.append('author', book.dataset.author);
    formData.append('cover', book.dataset.cover);
    fetch("unsave_books.php", {method: 'post', body: formData}).then(dispatchResponse, dispatchError);
    like.removeEventListener("click", unsaveBook);
    like.addEventListener("click", saveBook);
  }



//  8)
function saveBook(event){
    console.log("Salvataggio...");
    let like = event.currentTarget;
    like.src = "red_heart.png";
    const book = event.currentTarget.parentNode;
    book.classList.add("favourite");
    const cover = book.querySelector(".cover");
    cover.classList.add("favourite");
    // Preparo i dati da mandare al server e invio la richiesta con POST
    const formData = new FormData();
    formData.append('isbn', book.dataset.isbn);
    formData.append('title', book.dataset.title);
    formData.append('author', book.dataset.author);
    formData.append('cover', book.dataset.cover);
    fetch("save_books.php", {method: 'post', body: formData}).then(dispatchResponse, dispatchError);
    like.removeEventListener("click", saveBook);
    like.addEventListener("click", unsaveBook);
  }



//  7)
function jsonBooks(json) {
    console.log("Ricerca avviata.");
    console.log(json);
    const library = document.getElementById('book-grid');
    let num_results = json.num_found;
    if(num_results > 16){
        num_results = 16;
    }
    for(let i = 0; i < num_results; i++){
        const doc = json.docs[i];
        // Informazioni da salvare
        const book = document.createElement("div");
        const isbn = doc.isbn[0];
        book.dataset.isbn = isbn;
        const cover_url = "https://covers.openlibrary.org/b/isbn/" + isbn + "-M.jpg";
        book.dataset.title = doc.title;
        book.dataset.author = doc.author_name;
        book.dataset.cover = cover_url;
        book.classList.add("book");
        book.classList.add("da-rimuovere");
        const img = document.createElement("img");
        img.classList.add("cover");
        img.classList.add("da-rimuovere");
        img.src = cover_url;
        const t = document.createElement("span");
        t.textContent = doc.title;
        t.classList.add("title");
        t.classList.add("da-rimuovere");
        const save = document.createElement("img");
        save.classList.add("save");
        save.classList.add("da-rimuovere");
        if(db_isbn.includes(isbn)){
            save.src = "red_heart.png";
            book.classList.add("favourite");
        }
        else{
            save.src = "black_heart.png";
        }
        if(!book.classList.contains("favourite")){
            save.addEventListener("click", saveBook);
        }
        else{
            save.addEventListener("click", unsaveBook);
        }
        book.appendChild(img);
        book.appendChild(t);
        book.appendChild(save);
        library.appendChild(book);
    }
}


//  6)
function searchResponse(response){
    console.log(response);
    return response.json();
}



//  5)
function reset(){
    const elements = document.querySelectorAll(".da-rimuovere");
    for(const el of elements){
        el.remove();
    }
}



//  4)
function search(event){
    reset();
    // Leggo il contenuto da cercare e lo invio alla pagina PHP
    const form_data = new FormData(document.querySelector("#search_form"));
    // Mando le specifiche della richiesta alla pagina PHP, che prepara la richiesta e la inoltra
    fetch("search_content.php?q="+encodeURIComponent(form_data.get('search'))).then(searchResponse).then(jsonBooks);
    // Evito che la pagina venga ricaricata
    event.preventDefault();
}



//  3)
function fetchBooksJson(json) {
    console.log("Cerco tra i preferiti...");
    console.log(json);
    if(json.length != 0){
        for(let book in json){
            db_isbn[book] = json[book].isbn;
        }
    }
    console.log("Libri preferiti:");
    for(let i = 0; i < db_isbn.length; i++){
        console.log("Codice: " + db_isbn[i]);
    }
}



//  2)
function fetchResponse(response) {
    return response.json();
}



//  1)
let db_isbn = [];
fetch("fetch_book.php").then(fetchResponse).then(fetchBooksJson);
const search_form = document.querySelector("#search_form");
search_form.addEventListener("submit", search);


console.log("benvenuto!");
