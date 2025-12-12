const clickDown = new Audio("Audio/clickdown.mp3");
const signInButton = document.getElementById("signin-button");
const signInSubmit = document.getElementById("signin-submit");
const signUpSubmit = document.getElementById("signup-submit");

const bindSubmitSound = (buttonEl) => {
    if (!buttonEl || !buttonEl.form) return;
    buttonEl.addEventListener("click", (event) => {
        event.preventDefault();
        clickDown.play().catch((err) => console.warn("clickDown failed", err));
        const form = buttonEl.form;
        setTimeout(() => {
            if (typeof form.requestSubmit === "function") {
                form.requestSubmit(buttonEl); // keeps built-in validation
            } else {
                form.submit();
            }
        }, 150);
    });
};

// Landing page CTA: play sound then navigate
if (signInButton) {
    const target = signInButton.dataset?.target || "signin.php";
    signInButton.addEventListener("mousedown", () => {
        clickDown.play().catch((err) => console.warn("clickDown failed", err));
        setTimeout(() => { window.location.href = target; }, 150);
    });
}

bindSubmitSound(signInSubmit);
bindSubmitSound(signUpSubmit);

/* function pageRedirect(pageTitle) {
    if (pageTitle === "SkillQuest") {
        target = "signin.php";
    }
    else if (pageTitle === "SkillQuest - Sign In" || pageTitle === "SkillQuest - Sign Up") {
        window.location.href = "home.php";
    }

 };*/