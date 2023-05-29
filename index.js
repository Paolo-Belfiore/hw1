
function onJson(json){
    console.log("JSON ricevuto");
    console.log(json);
    
    const works = json.works;
    const covers_id = [];
    
    const max_covers = 3;
    let start_cover_index = 3;
    for(let i = 0; i < max_covers; i++){
        covers_id[i] = works[start_cover_index].cover_id;
        start_cover_index++;
    }
    const covers = document.querySelectorAll(".cover");
    for(let i = 0; i < covers_id.length; i++){
            const cover_url_2 = "http://covers.openlibrary.org/b/id/" + covers_id[i] + "-M.jpg";
            covers[i].src = cover_url_2;
    }
}



function onResponse(response){
    console.log('Risposta ricevuta');
    return response.json();
}





const rest_url = "http://openlibrary.org/subjects/fantasy.json";

const cover_url = "http://covers.openlibrary.org/b/id/";

fetch(rest_url).then(onResponse).then(onJson);