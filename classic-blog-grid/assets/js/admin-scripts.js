jQuery(document).ready(function ($) {
    $(document).on('click', '.clbgd-banner-main .notice-dismiss', function () {
        $.ajax({
            url: clbgd_admin_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'clbgd_dismiss_notice',
                nonce: clbgd_admin_object.nonce
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggle = document.querySelector(".dropdown-toggle");
    const dropdownMenu = document.querySelector(".dropdown-menu");
    const dropdownItems = document.querySelectorAll(".dropdown-item");
    const hiddenInput = document.querySelector("#sort_order");

    if (dropdownToggle !== null) {
        dropdownToggle.addEventListener("click", function () {
            dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
        });
    }

    dropdownItems.forEach(item => {
        item.addEventListener("click", function () {
            if (this.classList.contains("disabled")) {
                return;
            }
            dropdownToggle.textContent = this.textContent.trim();
            hiddenInput.value = this.dataset.value;
            dropdownMenu.style.display = "none";
        });
    });

    document.addEventListener("click", function (e) {
        if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.style.display = "none";
        }
    });
});
