<div id="flash-messages" class="fixed top-20 right-4 space-y-2 z-50">
    @if(session('success'))
        <div class="bg-green-500 text-white font-bold p-4 rounded-lg shadow-md flash-message" id="success-message">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white font-bold p-4 rounded-lg shadow-md flash-message" id="error-message">
            {{ session('error') }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessages = document.querySelectorAll('.flash-message');

        flashMessages.forEach(function (message) {
            setTimeout(function () {
                message.style.opacity = '0';
                setTimeout(function () {
                    message.style.display = 'none';
                }, 1000); // Match the CSS transition duration
            }, 3000); // 3 seconds

            message.addEventListener('click', function () {
                message.style.opacity = '0';
                setTimeout(function () {
                    message.style.display = 'none';
                }, 1000); // Match the CSS transition duration
            });
        });
    });
</script>

<style>
    .flash-message {
        transition: opacity 1s ease-in-out;
    }
</style>
