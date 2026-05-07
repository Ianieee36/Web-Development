function userPrompt() {

    let sentence = prompt("Enter several words separated by spaces:");

    let words = sentence.split(" ");

    let output = "";

    for (let i = 0; i < words.length; i++) {
        output += words[i] + "<br>";
    }

    document.getElementById("result").innerHTML = output;
}