console.log("services-tabs.js");





window.addEventListener("load", (event) => {
    // const button_x = document.getElementById("button_x")


    // console.log(button_x.dataset.isselected);


    const els = document.querySelectorAll(".tabs-btn");


    console.log(els);

    els.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            els.forEach((btn2) => {
                if(btn !== btn2) {
                    btn2.dataset.isselected = "false"
                }
            })

            btn.dataset.isselected = "true"
        })
    })


  });


