//assures that you have written an email address before sending the mealplan
var exists = document.getElementById("generate_mealplan");
if (exists) {
    document.getElementById("email").addEventListener("click", function(event) {
        document.getElementById('mealplan_error_msg').innerHTML = "";
        if (document.getElementById('mailaddress').value == "") {
            event.preventDefault();
            document.getElementById('mealplan_error_msg').innerHTML = "Tilføj en email madplanen skal sendes til";
        } else {
            document.getElementById('mealplan_form').submit();
        }
    });
}

//assures that you have chosen at least one ingredient before generating a mealplan
var exists = document.getElementById("generate_mealplan");
if (exists) {
    document.getElementById("generate_mealplan").addEventListener("click", function(event) {
        //resets the error message
        document.getElementById("mealplan_ingredient_error_msg").innerHTML = "";
        let allAreFilled = true;
        let msg = "";
        
        //checks if there has been chosen at least one ingredient
        if (document.getElementById("ingredient_mealplan_table").rows.length < 1) {
            allAreFilled = false;
            msg = "Angiv minimum 1 ingrediens til madplanen.\n";
        }
        
        if (!allAreFilled) {
        event.preventDefault();
        document.getElementById("mealplan_ingredient_error_msg").innerHTML = msg;
    } 
    else { 
        document.getElementById('ingredient_mealplan_form').submit();
    }
});
}

//global variable for ingredient rows to make sure no one has the same id
var rowIdCount = "x";

//adds ingredient to the ingredient table
function add_ingredient_mealplan() {
    //resets the error message 
    document.getElementById("mealplan_ingredient_error_msg").innerHTML = "";
    let allAreFilled = true;
    let msg = "";

    //checks if all the required fields has been filled
    if (document.getElementById("ingredients").value == "") {
        allAreFilled = false;
        msg = "Angiv en ingrediens før du tilføjer.\n";
    }

    if (!allAreFilled) {
        document.getElementById("mealplan_ingredient_error_msg").innerHTML = msg;
    } 
    else { 
        var table = document.getElementById("ingredient_mealplan_table");

        //adds header to the table with ingredients
        if (table.rows.length == 0) {
            var header = table.createTHead();
            var row = header.insertRow();    
            var cell1 = row.insertCell();
            cell1.innerHTML = "Ingrediens";
            var cell2 = row.insertCell();
            cell2.innerHTML = "#";
            
            //create a tbody for the table
            table.createTBody();
        }

        var rowCount = table.rows.length;
        if (rowIdCount == "x") {
          rowIdCount = rowCount;
        }  

        //checks if the ingredient already are added to the table
        for(var i= rowCount - 1; i >= 0; i--) {
            var row = table.rows[i];
            var text = row.cells[0].innerHTML;
            if(text.indexOf(document.getElementById("ingredients").value)!=-1){
                document.getElementById("mealplan_ingredient_error_msg").innerHTML = "Denne ingrediens er allerede tilføjet";
                return;
            }
        }
        
        //adds the ingredient to the table 
        var row = table.insertRow();
        row.setAttribute('id', 'meal_row'+rowIdCount);
        var cell1 = row.insertCell();
        cell1.innerHTML = document.getElementById("ingredients").value;
        
        //adds a delete a tag to the row
        var aTag = document.createElement('a');
        aTag.setAttribute('onclick', 'delete_ingredient('+rowIdCount+')');
        aTag.innerText = "Slet";
        
        var cell4 = row.insertCell();
        cell4.appendChild(aTag);
        
        //adding the ingredients to hidden fields to correctly adding them to the database
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "mealplan_ingredient"+rowIdCount+"");
        input.setAttribute("id", "hidden_meal_row"+rowIdCount);
        input.setAttribute("value", document.getElementById("ingredients").value);

        //append to form element that you want .
        document.getElementById("i").appendChild(input);      

        //update counter
        var count = document.getElementById("ingredient_counter").value;
        count += 1;
        document.getElementById("ingredient_counter").value = count;

        //added a row
        rowIdCount += 1;
        
        //refresh the chosen data after it was added to the ingredient table
        document.getElementById("ingredients").value = "";
    }
}

//delete ingredient from ingredient table
function delete_ingredient(row) {
    var table = document.getElementById("ingredient_mealplan_table");
    var elem = document.getElementById("hidden_meal_row"+row);
    var x = table.rows;
    var i;
    for (i = 0; i < x.length;i++) {
        if (x[i].id === ("meal_row"+row)) {
        table.deleteRow(i);
        elem.parentNode.removeChild(elem);
        return;
        }
    }
}