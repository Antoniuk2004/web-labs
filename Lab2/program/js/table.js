function deleteTable() {
    let tableContainer = document.getElementById("table-container");
    let table = tableContainer.getElementsByTagName("table")[0];
    if (table) {
        tableContainer.removeChild(table);
    }
}

function createTable() {
    let tableContainer = document.getElementById("table-container");
    let table = document.createElement("table");
    table.className = "table";
    table.id = "table";
    tableContainer.appendChild(table);
}

function fillTable(arrayOfTableValues) {
    let table = document.getElementById("table");
    for (let indexOfRow = 0; indexOfRow < arrayOfTableValues.length; indexOfRow++) {
        let newRow = document.createElement("tr");
        for (let indexOfColumn = 0; indexOfColumn < arrayOfTableValues[indexOfRow].length; indexOfColumn++) {
            let td = document.createElement("td");
            td.textContent = arrayOfTableValues[indexOfRow][indexOfColumn];
            newRow.appendChild(td);
        }
        table.appendChild(newRow);
    }
}