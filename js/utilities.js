document.addEventListener('DOMContentLoaded', RunUtilities(), false);

function RunUtilities() {
  var expanders = document.getElementsByClassName("expander");
  for(var i = 0; i < expanders.length; i++) {
    var inputs = expanders[i].children[0].getElementsByTagName("input");
    var expand = expanders[i].children[1];

    for(var j = 0; j < inputctions.length; j++) {
      inputs[j].addEventListener("click", function() {
        if(this.checked) {
          if (this.classList.contains("show")) {
            this.parentElement.parentElement.parentElement.parentElement.children[1].style.display = "block";
          } else if (this.classList.contains("hide")){
            this.parentElement.parentElement.parentElement.parentElement.children[1].style.display = "none";
          }
        }
      });
    }
  }

  var rockers = document.getElementsByClassName("rocker");
  var allRockees = [];
  for(var i = 0; i < rockers.length; i++) {
    var inputs = rockers[i].children[0].getElementsByTagName("input");
    var rockees = Array.from(rockers[i].children);
    allRockees = allRockees.concat(rockees);

    for(var j = 0; j < inputs.length; j++) {
        
      addRockerListener(inputs[j], rockees[j+1]);
    }
  }

  function addRockerListener(input, rockee) {
    input.addEventListener("click", function() {
        if(this.checked) {
            for(var k = 1; k < allRockees.length; k++) {
                allRockees[k].style.display = "none";
            }
            rockee.style.display = "block";
        }
      });
  }
}