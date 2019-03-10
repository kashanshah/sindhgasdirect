<footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
        <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="http://www.elitetech.ae">EliteTech</a>.</strong> All rights reserved.
        </div>
        <!-- Default to the left -->
          Powered by <a href="http://www.elitetech.ae">EliteTech</a>
      </footer>
<script>
    // multi tab detection
    function register_tab_GUID() {
        // detect local storage available
        if (typeof (Storage) !== "undefined") {
            // get (set if not) tab GUID and store in tab session
            if (sessionStorage["tabGUID"] == null) sessionStorage["tabGUID"] = tab_GUID();
            var guid = sessionStorage["tabGUID"];

            // add eventlistener to local storage
            window.addEventListener("storage", storage_Handler, false);

            // set tab GUID in local storage
            localStorage["tabGUID"] = guid;
        }
    }

    function storage_Handler(e) {
        // if tabGUID does not match then more than one tab and GUID
        if (e.key == 'tabGUID') {
            if (e.oldValue != e.newValue) tab_Warning();
        }
    }

    function tab_GUID() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
    }

    function tab_Warning() {
        alert("Another tab is open!");
        document.body.innerHTML = '<h1 style="text-align:center;">The System is running on another tab!</h1>';
    }
</script>