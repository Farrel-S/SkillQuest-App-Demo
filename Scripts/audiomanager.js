const clickDown = new Audio("Audio/clickdown.mp3");
const signInButton = document.getElementById("signin-button");

// Only bind if the element exists to avoid runtime errors when reused on other pages
if (signInButton) {
    signInButton.addEventListener("mousedown", () => {
        clickDown.play().catch((err) => console.warn("clickDown failed", err));

        const target = signInButton.dataset.target || "signin.php";
        setTimeout(() => { window.location.href = target; }, 150);
    });
}