<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Element Payment</title>
    <link rel="stylesheet" href="{{ asset('checkout.css') }}" />
    <script src="https://js.stripe.com/v3/"></script> {{-- TODO: REFACTOR --}}
  </head>
  <body>
    <form id="payment-form">
      <div id="payment-element">
      </div>
      <button id="submit">
        <div class="spinner hidden" id="spinner"></div>
        <span id="button-text">Pay now</span>
      </button>
      <div id="payment-message" class="hidden"></div>
    </form>
    <script>
      const { clientSecret, clientPublic, url } = {!! $payment !!}
      
      const stripe = Stripe(clientPublic);

      const elements = stripe.elements({ clientSecret });
      const paymentElement = elements.create("payment");
      paymentElement.mount("#payment-element");

      document
        .querySelector("#payment-form")
        .addEventListener("submit", handleSubmit);

      async function handleSubmit(e) {
        e.preventDefault();
        setLoading(true);
        const { error } = await stripe.confirmPayment({
          elements,
          confirmParams: {
            return_url: url,
          },
        });
        if (error.type === "card_error" || error.type === "validation_error") {
          showMessage(error.message);
        } else {
          showMessage("An unexpected error occurred.");
        }
        setLoading(false);
      }

      function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");
        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;
        setTimeout(function () {
          messageContainer.classList.add("hidden");
          messageText.textContent = "";
        }, 4000);
      }

      function setLoading(isLoading) {
        if (isLoading) {
          document.querySelector("#submit").disabled = true;
          document.querySelector("#spinner").classList.remove("hidden");
          document.querySelector("#button-text").classList.add("hidden");
        } else {
          document.querySelector("#submit").disabled = false;
          document.querySelector("#spinner").classList.add("hidden");
          document.querySelector("#button-text").classList.remove("hidden");
        }
      }
    </script>  
  </body>
</html>