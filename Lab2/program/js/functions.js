let arrayOfTableValues = [];
let numOfRows;
let numOfColumns;


const getValueFromInput = (name) =>
    document.getElementById(name).value;


const getValueFromSelect = () =>
    document.getElementById("variants").value;



function create_matrix() {
    numOfRows = getValueFromInput("number-of-rows-input");
    numOfColumns = getValueFromInput("number-of-columns-input");

    const expression = getValueFromSelect();
    const parsedExpression = parseString(expression);

    arrayOfTableValues = create_arrayOfTableValuesay(numOfRows, numOfColumns, parsedExpression);

    deleteTable();
    createTable();
    fillTable(arrayOfTableValues);
}

function addOptionsToSelect() {
    let variantSelect = document.getElementById("variants");
    let index = 0;
    variants.forEach(element => {
        let option = document.createElement("option");
        option.textContent = index + 1 + ") " + element;
        option.value = element;
        variantSelect.appendChild(option);
        index++;
    });
}


function create_arrayOfTableValuesay(numOfRows, numOfColumns, expression) {
    let arrayOfTableValues = [];
    for (let indexOfRow = 0; indexOfRow < numOfRows; indexOfRow++) {
        let row = [];
        for (let indexOfColumn = 0; indexOfColumn < numOfColumns; indexOfColumn++) {
            const value = calculateValue(indexOfRow, indexOfColumn, expression);
            row.push(value);
        }
        arrayOfTableValues.push(row);
    }
    return arrayOfTableValues;
}

function parseString(expression) {
    const letterPattern = /^[A-Za-z]$/;
    const digitPattern = /^[0-9]$/;;

    for (let i = 0; i < expression.length; i++) {
        const val = expression[i];
        if (letterPattern.test(val) && i != 0) {
            const prev = expression[i - 1];
            if (digitPattern.test(prev)) {
                expression = expression.substring(0, i) + "*" + expression.substring(i, expression.length);
            }
        }
    }
    return expression;
}

function handleTextInput() {
    let inputElements = document.getElementsByClassName("input");

    inputElements = [...inputElements];
    inputElements.forEach(element => {
        element.addEventListener("change", function (event) {
            deleteTable();
            arrayOfTableValues = [];
        });
    });
}

function handleSelectChange() {
    let selectElement = document.getElementById("variants");
    selectElement.addEventListener("change", function () {
        deleteTable();
        arrayOfTableValues = [];
    });
}

function outputAnswer(result) {
    const message = `Cума елементів отриманого двовимірного масиву${test(result.sumOfAllElements, false)};\n` +
        `Сума елементів другого рядка${test(result.sumOfTheSecondRow, false)};\n` +
        `Cума елементів третього стовпця${test(result.sumOfTheThirdColumn, false)};\n` +
        `Сума елементів порядковий номер строки та стовпця яких співпадають${test(result.sumOfNumbersWithTheSameIndexes, false)};\n` +
        `Добуток елементів останнього стовпця${test(result.productOfTheLastColumn, true)}.`;
    alert(message);
    console.log(message)
}

function test(value, isMale) {
    if (Number.isNaN(value)) {
        if (isMale) return " не є можливим";
        else return " не є можливою";
    }
    else return (`: ${Math.round(value, 4)}`)
}