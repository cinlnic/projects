//tells js parser to follow all rules strictly
'use strict'

/**get a list of vehicles in inventory based on the classificationId**/

//finds classificationList id in v-man page stores it into local js variable
let classificationList = document.querySelector("#classificationList");

//attaches event listener to classificationList variable and when change occurs an anonymous funtion is executed
classificationList.addEventListener("change", function() {
    let classificationId = classificationList.value;
    console.log(`classificationId is: ${classificationId}`);
    let classIdURL = "/phpmotors/vehicles/index.php?action=getInventoryItems&classificationId=" + classificationId;

    //initiates AJAX request
    fetch(classIdURL)

    .then(function (response) {
        if (response.ok) {
            return response.json();
        }
        throw Error("Newtork response was not OK");
    })

    .then(function (data) {
        console.log(data);
        buildInventoryList(data);
    })

    .catch(function (error) {
        console.log('There was a problem: ', error.message)
    })
})

/**Build inventory items into HTML table components and inject into DOM**/
function buildInventoryList(data) {
    let inventoryDisplay = document.getElementById("inventoryDisplay");
    
    //set up table labels
    let dataTable = '<thead>';
    dataTable += '<tr><th>Vehicle Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
    dataTable += '</thead>';

    //set up table body
    dataTable += '<tbody>';

    //iterate over all vehicles in the array and put each in a row
    data.forEach(function (element) {
        console.log(element.invId + ", " + element.invModel);
        dataTable += `<tr><td>${element.invMake} ${element.invModel}</td>`;
        dataTable += `<td><a href='/phpmotors/vehicles?action=mod&id=${element.invId}' title='Click to Modify'>Modify</a></td>`;
        dataTable += `<td><a href='/phpmotors/vehicles?action=del&id=${element.invId}' title='Click to Delete'>Delete</a></td></tr>`;
    })

    dataTable += '</tbody>';

    //Display the contents in the vehicle management view
    inventoryDisplay.innerHTML = dataTable;
}
