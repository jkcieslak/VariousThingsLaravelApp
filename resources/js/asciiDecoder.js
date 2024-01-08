document.getElementById("decode-button").addEventListener("click", () => {
    const inputElem = document.getElementById("ascii-text");
    const outputElem = document.getElementById("decoded-text");
    let outputStr = '';
    let inputStr = inputElem.textContent;
    for (let i = 0; i < inputStr.length; i += 2) {
        outputStr += parseInt(inputStr.substring(i, i+2), 16)
            .toString(10);
    }
    outputElem.textContent = outputStr;
})
