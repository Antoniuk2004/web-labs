function calculateValue(i, j, expression) {
    expression = expression.replace("i", i);
    expression = expression.replace("j", j);
    const res = eval(expression);
    if (res === Infinity) return NaN;
    else return parseFloat(res.toFixed(4));
}


function calculate() {
    if(arrayOfTableValues.length != 0){
        const sumOfAllElements = calculateSumOfAllElements(arrayOfTableValues);
        let sumOfTheSecondRow = calculateSumOfTheSecondRow(arrayOfTableValues, numOfRows);
        let sumOfTheThirdColumn = calculateSumOfTheThird(arrayOfTableValues, numOfRows, numOfColumns);
        let sumOfNumbersWithTheSameIndexes = calculateSumOfNumbersWithTheSameIndexes(arrayOfTableValues, numOfRows, numOfColumns);
        let productOfTheLastColumn = calculateProductOfTheLastColumn(arrayOfTableValues, numOfRows, numOfColumns);
    
        const result = {
            sumOfAllElements: sumOfAllElements,
            sumOfTheSecondRow: sumOfTheSecondRow,
            sumOfTheThirdColumn: sumOfTheThirdColumn,
            sumOfNumbersWithTheSameIndexes: sumOfNumbersWithTheSameIndexes,
            productOfTheLastColumn: productOfTheLastColumn,
        }
        
        outputAnswer(result);
    }
    else alert("Побудуйте таблицю перед розрахунком.");
}

function calculateSumOfTheThird(arrayOfTableValues, numOfRows, numOfColumns) {
    if (numOfColumns > 2) {
        let sum = 0;
        for (let index = 0; index < numOfRows; index++) {
            sum += arrayOfTableValues[index][2];
        }
        return sum;
    }
    else return undefined;
}

function calculateSumOfNumbersWithTheSameIndexes(arrayOfTableValues, numOfRows, numOfColumns) {
    let sum = 0;
    for (let rowIndex = 0; rowIndex < numOfRows; rowIndex++) {
        for (let columnIndex = 0; columnIndex < numOfColumns; columnIndex++) {
            if (rowIndex == columnIndex) sum += arrayOfTableValues[rowIndex][columnIndex];
        }
    }
    return sum;
}

function calculateProductOfTheLastColumn(arrayOfTableValues, numOfRows, numOfColumns) {
    let product = 1;
    for (let index = 0; index < numOfRows; index++) {
        product *= arrayOfTableValues[index][numOfColumns - 1];
    }
    return product;
}

function calculateSumOfAllElements(arrayOfTableValues) {
    let sum = 0;
    for (let rowIndex = 0; rowIndex < arrayOfTableValues.length; rowIndex++) {
        for (let columnIndex = 0; columnIndex < arrayOfTableValues[rowIndex].length; columnIndex++) {
            sum += arrayOfTableValues[rowIndex][columnIndex];
        }
    }
    return sum;
}

function calculateSumOfTheSecondRow(arrayOfTableValues, numOfRows) {
    if (numOfRows > 1) {
        let sum = 0;
        for (let index = 0; index < arrayOfTableValues[1].length; index++) {
            sum += arrayOfTableValues[1][index];
        }
        return sum;
    }
    else return undefined;
}