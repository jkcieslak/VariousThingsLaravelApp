document.getElementById("decode-button").addEventListener("click", () => {
    const inputElem = document.getElementById("ascii-text");
    const outputElem = document.getElementById("decoded-text");
    let outputStr = '';
    let inputStr = inputElem.value;
    for (let i = 0; i < inputStr.length; i += 2) {
        if(inputStr[i] === '\n') {
            outputStr += '\n';
            i--;
            continue;
        }
        outputStr += String.fromCharCode(parseInt(inputStr.substring(i, i+2), 16));
    }
    outputElem.textContent = outputStr;
})
