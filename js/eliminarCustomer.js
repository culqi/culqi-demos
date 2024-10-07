function deleteCustomer(customerId) {
    $.ajax({
      type: 'POST',
      url: 'http://localhost/culqi-recurrencia-v4/culqi-php-develop/examples/26-delete-customer.php',
      data: { customerId: customerId },
      datatype: 'json',
      success: function (data) {
        var result = "";
        if (data) {
          result = data.merchant_message;
          alert(result);
          getListCustomers()
        }
      },
      error: function (error) {
        console.log("error: ", error);
      }
    });
  };