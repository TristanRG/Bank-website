let slideIndex = 0;

function showSlides() {
    const container = document.getElementById("slideshow-container");
    container.innerHTML = ""; 

    const images = ["banking1.png", "banking2.png", "banking3.png"];

    images.forEach((imagePath, index) => {
        const slide = document.createElement("div");
        slide.className = "mySlides";
        slide.style.display = "none";
        
        const img = document.createElement("img");
        img.src = imagePath;
        img.alt = `Slide ${index + 1}`;
        
        slide.appendChild(img);
        container.appendChild(slide);
    });

    slideIndex++;
    if (slideIndex > images.length) {
        slideIndex = 1;
    }

    const slides = document.getElementsByClassName("mySlides");
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 5000); // timer
}

showSlides(); 
