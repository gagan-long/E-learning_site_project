var crsr = document.querySelector("#cursor")
var blur = document.querySelector("#cursor-blur")
document.addEventListener("mousemove",function(dets){
    // console.log(dets.y)
    // crsr.style.left = dets.x + "px"   
    // crsr.style.top = dets.y + "px"
    blur.style.left = dets.x - 150 +"px"   
    blur.style.top = dets.y - 150 +"px"

})

function toggleMenu() {
    const navLinks = document.getElementById('nav_links');
    
    // Toggle 'active' class to show/hide the menu
    navLinks.classList.toggle('active');
}

// var h4all = document.querySelectorAll("#nav h4")
// h4all.forEach(function(elem){
//     elem.addEventListener("mouseenter",function(){
//         crsr.style,scale = 6
//         crsr.style.border = "1px solid #fff"
//         crsr.style.backgroundColor = "transparent"
//     })
//     elem.addEventListener("mouseleave",function(){
//         crsr.style,scale = 1
//         crsr.style.border = "0px solid  #0c38497c"
//         crsr.style.backgroundColor = " #0c38497c"
//     })
// })


// gsap.to("#nav",{
//     backgroundColor :"#000",
//     hight:"110px",
//     duration:0.5,
//     delay:1,
//     scrollTrigger:{
//         trigger:"#nav",
//         scroller:"body",
//         // markers:true,
//         start:"top -10%",
//         end:"top -11%",
//         scrub:1
//     }
// })  

// gsap.to("#main",{
//     backgroundColor:"#000",
//     delay:1,
//     scrollTrigger:{
//         trigger:"#main",
//         scroller:"body",
//         start:"top -20%",
//         end:"top -80v%",
//         scrub:2
//     }
// })

