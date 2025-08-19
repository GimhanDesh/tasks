function userRegister() {
  var name = document.getElementById("name").value;
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var address = document.getElementById("address").value;
  var contact = document.getElementById("contact").value;
  var dob = document.getElementById("dob").value;

  if (name == "" || name == null) {
    alert("Please enter name...!");
  } else if (email == "" || email == null) {
    alert("Please enter email...!");
  } else if (password == "" || password == null) {
    alert("Please enter password...!");
  } else if (address == "" || address == null) {
    alert("Please enter address...!");
  } else if (contact == "" || contact == null) {
    alert("Please enter contact...!");
  } else if (dob == "" || dob == null) {
    alert("Please enter Date of Birth...!");
  } else {
    var form = new FormData();
    form.append("name", name);
    form.append("email", email);
    form.append("password", password);
    form.append("address", address);
    form.append("contact", contact);
    form.append("dob", dob);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var response = JSON.parse(r.responseText);
        if (response.success) {
          alert(response.message);
          window.location.reload();
          window.location.href = "login.php";
        } else alert(response.message);
      }
    };
    r.open("POST", "userRegisterProcess.php", true);
    r.send(form);
  }
}

function userLogin() {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;

  if (email == "" || email == null) {
    alert("Please enter email...!");
  } else if (password == "" || password == null) {
    alert("Please enter password...!");
  } else {
    var form = new FormData();
    form.append("email", email);
    form.append("password", password);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var response = JSON.parse(r.responseText);
        if (response.success) {
          alert(response.message);
          window.location.reload();
          window.location.href = "home.php";
        } else {
          alert(response.message);
        }
      }
    };
    r.open("POST", "userLoginProcess.php", true);
    r.send(form);
  }
}

function uploadImgs() {
  var fileInput = document.getElementById("prescription");
  var files = fileInput.files;

  if (files.length === 0) {
    alert("Please Select Prescription Images");
    return;
  } else if (files.length > 5) {
    alert("You can only upload up to 5 files.");
    return;
  }

  var form = new FormData();
  for (var i = 0; i < files.length; i++) {
    form.append("image[]", files[i]);
  }

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var response = JSON.parse(r.responseText);
      if (response.success) {
        alert(response.message);
      } else {
        alert(response.message);
      }
    }
  };
  r.open("POST", "addImagesProcess.php", true);
  r.send(form);
}

function viewPrescription(id){
    window.location.href = "addQuotation.php?id="+id;
}

function addDrugs(id){
    var drug = document.getElementById("drug").value;
    var qty = document.getElementById("qty").value;

    if(drug==0){
        alert("Please select a drug First");
    }else if(qty<1||qty==null){
        alert("please Add Valid Quantity");
    }else{
 var form = new FormData();
    form.append("id", id);
    form.append("drug", drug);
    form.append("qty", qty);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {

        var response = r.responseText;
      var table = document.getElementById("tableBody");
      table.innerHTML = response;
        
        
      }
    };
    r.open("POST", "addDrugsProcess.php", true);
    r.send(form);
    }

    
}

function changeStatus(id,status) {

   var form = new FormData();
    form.append("id", id);
    form.append("status", status);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4) {
        if (r.status == 200) {
          try {
            var response = JSON.parse(r.responseText);
            if (response.success) {
                alert(response.message);
              window.location.reload();
            } else {
              alert(response.message);
            }
          } catch (error) {
            alert("Invalid JSON response: " + error.message);
          }
        } else {
          alert("Email sending error occurred! Status: " + r.status);
        }
      }
    };
    r.open("POST", "changeStatusProcess.php", true);
    r.send(form);
  
}
