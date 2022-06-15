///----------------- Functions for the add modal -----------------///
function next_modal() {
    //resets the error message tag
    document.getElementById("error_msg").innerHTML = "";
    let allAreFilled = true;
    let msg = "";
    
    //checks if all the required fields has been filled
    if (document.getElementById("meal_name").value == "") {
      allAreFilled = false;
      msg = "Angiv et navn til retten.\n";
    }
    if (document.getElementById("meal_time").value == "" || document.getElementById("meal_time").innerHTML > 0) {
      allAreFilled = false;
      msg += "Angiv en tid til retten.\n";
    }
    if (document.getElementById("count").value == "") {
      allAreFilled = false;
      msg += "Angiv antal personer til retten.";
    }
  
    if (!allAreFilled) {
      document.getElementById("error_msg").innerHTML = msg;
    } 
    else { 
      document.getElementById("ingredient-info").style.display = 'unset';
      document.getElementById("start-info").style.display = 'none';
    }
  }

function last_modal() {
    //resets the error message
    document.getElementById("error_ingredient").innerHTML = "";
    let allAreFilled = true;
    let msg = "";
    
    //checks if all the required fields has been filled
    if (document.getElementById("ingredient_table").rows.length < 1) {
      allAreFilled = false;
      msg = "Angiv minimum 1 ingrediens til retten.\n";
    }
  
    if (!allAreFilled) {
      document.getElementById("error_ingredient").innerHTML = msg;
    } 
    else { 
      document.getElementById("course-info").style.display = 'unset';
      document.getElementById("ingredient-info").style.display = 'none';
    }
}

//global variable for ingredient rows to make sure no one has the same id
var rowIdCount = "x";
  //adds ingredient to the ingredient table
function add_ingredient() {
    //resets the error message 
    document.getElementById("error_ingredient").innerHTML = "";
    let allAreFilled = true;
    let msg = "";

    //checks if all the required fields has been filled
    if (document.getElementById("meal_ingredients").value == "") {
        allAreFilled = false;
        msg = "Angiv en ingrediens før du tilføjer.\n";
    }
    if (document.getElementById("amount").value == "" || document.getElementById("amount").innerHTML > 0) {
        allAreFilled = false;
        msg += "Angiv mængden af ingrediensen.\n";
    }
    if (document.getElementById("unit").value == "") {
        allAreFilled = false;
        msg += "Angiv måleenheden til ingrediensen.";
    }

    if (!allAreFilled) {
        document.getElementById("error_ingredient").innerHTML = msg;
    } 
    else { 
        var table = document.getElementById("ingredient_table");

        //adds header to the table with ingredients
        if (table.rows.length == 0) {
            var header = table.createTHead();
            var row = header.insertRow();    
            var cell1 = row.insertCell();
            cell1.innerHTML = "Ingrediens";
            var cell2 = row.insertCell();
            cell2.innerHTML = "Mængde";
            var cell3 = row.insertCell();
            cell3.innerHTML = "Måleenhed";
            var cell4 = row.insertCell();
            cell4.innerHTML = "#";
            
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
            if(text.indexOf(document.getElementById("meal_ingredients").value)!=-1){
                document.getElementById("error_ingredient").innerHTML = "Denne ingrediens er allerede tilføjet";
                exit();
            }
        }
        
        //adds the ingredient to the table 
        var row = table.insertRow();
        row.setAttribute('id', 'row'+rowIdCount);
        var cell1 = row.insertCell();
        cell1.innerHTML = document.getElementById("meal_ingredients").value;
        // cell1.name = 
        var cell2 = row.insertCell();
        cell2.innerHTML = document.getElementById("amount").value;
        var cell3 = row.insertCell();
        cell3.innerHTML = document.getElementById("unit").value;
        
        //adds a delete a tag to the row
        var aTag = document.createElement('a');
        aTag.setAttribute('onclick', 'delete_added_ingredient('+rowIdCount+')');
        aTag.innerText = "Slet";
        
        var cell4 = row.insertCell();
        cell4.appendChild(aTag);
        
        //adding the ingredients to hidden fields to correctly adding them to the database
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "ingredient"+rowIdCount+"");
        input.setAttribute("id", "hidden_row"+rowIdCount);
        input.setAttribute("value", (document.getElementById("meal_ingredients").value + '|' + document.getElementById("amount").value + '|' + document.getElementById("unit").value));

        //append to form element that you want 
        document.getElementById("m_i").appendChild(input);      

        //update counter
        var count = document.getElementById("counter").value;
        var newCount = parseInt(count) + 1;
        document.getElementById("counter").value = newCount.toString();

        //added a row
        rowIdCount += 1;

        refresh_removed_ingredient();
    }
}

//delete ingredient from ingredient table
function delete_added_ingredient(row) {
  var table = document.getElementById("ingredient_table");
  var elem = document.getElementById("hidden_row"+row);
  var x = table.rows;
  var i;

  if (rowIdCount == "x") {
    rowIdCount = x.length;
  }

  for (i = 0; i < x.length;i++) {
    if (x[i].id === ("row"+row)) {
      table.deleteRow(i);
      elem.parentNode.removeChild(elem);
      return;
    }
  }
}

//refresh the chosen data after it was added to the ingredient table
function refresh_removed_ingredient() {
    document.getElementById("meal_ingredients").value = "";
    document.getElementById("amount").value = "";
    document.getElementById("unit").value = "";
}


///----------------- Functions for the edit modal -----------------///
function edit_next_modal(id) {
    //resets the error message tag
    document.getElementById("edit_error_msg"+id).innerHTML = "";
    let allAreFilled = true;
    let msg = "";
  
  //checks if all the required fields has been filled
  if (document.getElementById("edit_meal_name"+id).value == "") {
    allAreFilled = false;
    msg = "Angiv et navn til retten.\n";
  }
  if (document.getElementById("edit_meal_time"+id).value == "" || document.getElementById("edit_meal_time"+id).innerHTML > 0) {
    allAreFilled = false;
    msg += "Angiv en tid til retten.\n";
  }
  if (document.getElementById("edit_count"+id).value == "") {
    allAreFilled = false;
    msg += "Angiv antal personer til retten.";
  }
  
  if (!allAreFilled) {
    document.getElementById("edit_error_msg"+id).innerHTML = msg;
  } 
  else { 
    document.getElementById("edit-ingredient-info"+id).style.display = 'unset';
    document.getElementById("edit-start-info"+id).style.display = 'none';
  }
}

function edit_last_modal(id) {
  //resets the error message
  document.getElementById("edit_error_ingredient"+id).innerHTML = "";
  let allAreFilled = true;
  let msg = "";
  
  //checks if all the required fields has been filled
  if (document.getElementById("edit_ingredient_table"+id).rows.length < 1) {
    allAreFilled = false;
    msg = "Angiv minimum 1 ingrediens til retten.\n";
  }

  if (!allAreFilled) {
    document.getElementById("edit_error_ingredient"+id).innerHTML = msg;
  } 
  else { 
    document.getElementById("edit-course-info"+id).style.display = 'unset';
    document.getElementById("edit-ingredient-info"+id).style.display = 'none';
  }
}

//global variable for ingredient rows to make sure no one has the same id
var rowIdCount = "x";
//adds ingredient to the ingredient table
function edit_add_ingredient(id) {
  //resets the error message 
  document.getElementById("edit_error_ingredient"+id).innerHTML = "";
  let allAreFilled = true;
  let msg = "";

  //checks if all the required fields has been filled
  if (document.getElementById("edit_meal_ingredients"+id).value == "") {
      allAreFilled = false;
      msg = "Angiv en ingrediens før du tilføjer.\n";
  }
  if (document.getElementById("edit_amount"+id).value == "" || document.getElementById("edit_amount"+id).innerHTML > 0) {
      allAreFilled = false;
      msg += "Angiv mængden af ingrediensen.\n";
  }
  if (document.getElementById("edit_unit"+id).value == "") {
      allAreFilled = false;
      msg += "Angiv måleenheden til ingrediensen.";
  }

  if (!allAreFilled) {
      document.getElementById("edit_error_ingredient"+id).innerHTML = msg;
  } 
  else { 
      var table = document.getElementById("edit_ingredient_table"+id);

      //adds header to the table with ingredients
      if (table.rows.length == 0) {
          var header = table.createTHead();
          var row = header.insertRow();    
          var cell1 = row.insertCell();
          cell1.innerHTML = "Ingrediens";
          var cell2 = row.insertCell();
          cell2.innerHTML = "Mængde";
          var cell3 = row.insertCell();
          cell3.innerHTML = "Måleenhed";
          var cell4 = row.insertCell();
          cell4.innerHTML = "#";
          
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
          if(text.indexOf(document.getElementById("edit_meal_ingredients"+id).value)!=-1){
              document.getElementById("edit_error_ingredient"+id).innerHTML = "Denne ingrediens er allerede tilføjet";
              exit();
          }
      }
      
      //adds the ingredient to the table 
      var row = table.insertRow();
      row.setAttribute('id', 'edit_row'+rowIdCount);
      var cell1 = row.insertCell();
      cell1.innerHTML = document.getElementById("edit_meal_ingredients"+id).value;
      // cell1.name = 
      var cell2 = row.insertCell();
      cell2.innerHTML = document.getElementById("edit_amount"+id).value;
      var cell3 = row.insertCell();
      cell3.innerHTML = document.getElementById("edit_unit"+id).value;
      
      //adds a delete a tag to the row
      var aTag = document.createElement('a');
      aTag.setAttribute('onclick', 'edit_delete_ingredient('+rowIdCount+','+id+')');
      aTag.innerText = "Slet";
      
      var cell4 = row.insertCell();
      cell4.appendChild(aTag);
      
      //adding the ingredients to hidden fields to correctly adding them to the database
      var input = document.createElement("input");
      input.setAttribute("type", "hidden");
      input.setAttribute("name", "edit_ingredient"+rowIdCount+"");
      input.setAttribute("id", "hidden_edit_row"+rowIdCount+"");
      input.setAttribute("value", ('0|'+document.getElementById("edit_meal_ingredients"+id).value + '|' + document.getElementById("edit_amount"+id).value + '|' + document.getElementById("edit_unit"+id).value));

      //append to form element that you want
      document.getElementById("edit_m_i"+id).appendChild(input);      

      //update counter
      var count = document.getElementById("counter"+id).value;
      count += 1;
      document.getElementById("counter"+id).value = count;

      //added a row
      rowIdCount += 1;

      //refreshs the ingredient fields
      edit_refresh_ingredient(id);
  }
}

//delete ingredient from ingredient table
function edit_delete_ingredient(row,id) {
  var table = document.getElementById("edit_ingredient_table"+id);
  var elem = document.getElementById("hidden_edit_row"+row);
  var x = table.rows;
  var i;

  if (rowIdCount == "x") {
    rowIdCount = x.length;
  }

  for (i = 0; i < x.length;i++) {
    if (x[i].id === ("edit_row"+row)) {
      table.deleteRow(i);
      elem.parentNode.removeChild(elem);
      return;
    }
  }
}

//refresh the chosen data after it was added to the ingredient table
function edit_refresh_ingredient(id) {
  document.getElementById("edit_meal_ingredients"+id).value = "";
  document.getElementById("edit_amount"+id).value = "";
  document.getElementById("edit_unit"+id).value = "";
}