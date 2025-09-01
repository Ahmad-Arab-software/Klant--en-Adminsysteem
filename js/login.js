// Password visibility toggle
document
  .getElementById("togglePassword")
  .addEventListener("click", function () {
    const passwordField = document.getElementById("passwordField");
    const eyeIcon = document.getElementById("eyeIcon");
    const eyeOffIcon = document.getElementById("eyeOffIcon");

    if (passwordField.type === "password") {
      passwordField.type = "text";
      eyeIcon.classList.add("hidden");
      eyeOffIcon.classList.remove("hidden");
    } else {
      passwordField.type = "password";
      eyeIcon.classList.remove("hidden");
      eyeOffIcon.classList.add("hidden");
    }
  });

// Enhanced error display
function showError(message) {
  const errorElement = document.getElementById("error");
  errorElement.innerHTML = `
            <div class="flex items-center justify-center">
                <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                ${message}
            </div>
        `;
  errorElement.classList.remove("hidden");
  errorElement.classList.add("animate-fade-up");
}

function hideError() {
  const errorElement = document.getElementById("error");
  errorElement.classList.add("hidden");
  errorElement.classList.remove("animate-fade-up");
}

// Original login functionality (unchanged)
document
  .getElementById("loginForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();
    hideError();

    // Add loading state to button
    const submitButton = e.target.querySelector('button[type="submit"]');
    const originalHTML = submitButton.innerHTML;
    submitButton.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Inloggen...
            </span>
        `;
    submitButton.disabled = true;

    const form = e.target;
    const formData = new FormData(form);
    const payload = new URLSearchParams(formData);

    try {
      const res = await fetch(
        "https://api.interpol.sd-lab.nl/api/create-session",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: payload,
        }
      );

      let data;
      try {
        data = await res.json();
        console.log(data);
      } catch (err) {
        console.log(err);
        showError("Gebruik een geldig school-account.");
        return;
      }

      if (data.message && data.session) {
        // Sessie lokaal in PHP opslaan
        const setSession = await fetch("index.php?page=set-session", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ session: data.session }),
        });

        const setResult = await setSession.json();

        if (setResult.status === "ok") {
          if (data.session.ingelogdAls === "DOCENT") {
            window.location = "index.php?page=dashboard";
          } else {
            window.location = "../test_ph/klant/views/index.php";
          }
        } else {
          showError("Kon sessie niet aanmaken.");
        }
      } else {
        showError(data.error ?? "Ongeldige inloggegevens.");
      }
    } catch (error) {
      showError(
        "Deze website is tijdelijk offline omdat het onderdeel is van een schoolproject en de school alle servers tijdelijk heeft uitgeschakeld."
      );
    } finally {
      // Reset button state
      submitButton.innerHTML = originalHTML;
      submitButton.disabled = false;
    }
  });
