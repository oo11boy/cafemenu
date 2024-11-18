
  
  // درخواست گارسون
  var openModalBtn = document.getElementById('open-modal');
  var closeModalBtn = document.getElementById('close-modal');
  var waiterModal = document.getElementById('waiter-modal');
  var submitRequestBtn = document.getElementById('submit-request');
  var tableNumberInput = document.getElementById('table-number');

  openModalBtn.addEventListener('click', function() {
      waiterModal.classList.remove('hidden');
      waiterModal.classList.add('modal-enter');
      setTimeout(function() {
          waiterModal.classList.add('modal-enter-active');
      }, 10);
  });

  closeModalBtn.addEventListener('click', function() {
      waiterModal.classList.add('modal-exit-active');
      waiterModal.classList.remove('modal-enter-active');
      setTimeout(function() {
          waiterModal.classList.add('hidden');
          waiterModal.classList.remove('modal-exit-active');
          waiterModal.classList.remove('modal-enter');
      }, 300);
  });

  submitRequestBtn.addEventListener('click', function() {
      var tableNumber = tableNumberInput.value;
      if (tableNumber === '') {
          alert('لطفا شماره میز را وارد کنید');
          return;
      }

      var xhr = new XMLHttpRequest();
      xhr.open('POST', ajax_object.ajax_url, true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
          if (xhr.status >= 200 && xhr.status < 400) {
              var response = JSON.parse(xhr.responseText);
              if (response.success) {
                  alert('درخواست شما ارسال شد');
                  waiterModal.classList.add('hidden');
                  tableNumberInput.value = '';
              } else {
                  alert('مشکلی در ارسال درخواست وجود دارد');
              }
          } else {
              alert('مشکلی در سرور وجود دارد');
          }
      };

      xhr.onerror = function() {
          alert('درخواست شما ارسال نشد، مشکل شبکه‌ای وجود دارد');
      };

      xhr.send('action=submit_waiter_request&table_number=' + encodeURIComponent(tableNumber));
  });
