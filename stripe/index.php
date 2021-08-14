<?php require_once('./config.php'); ?>



  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo $stripe['publishable_key']; ?>"
          data-description="acceso par aun ano"
          data-amount="1000"
          data-locale="auto">
            
  </script>
</form>