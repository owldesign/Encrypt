<field-encrypt>

    <input ref="input" class="uk-width-1-1" bind="{opts.bind}" type="text">

    <script>

        var $this = this;
        this.value = '';

        decryptValue(value) {
            App.request('/encryption/decrypt', {value: value}).then(function(result) {
                $this.refs.input.value = result
            });
        }

        this.on('mount', function() {
            this.value = this.decryptValue(this.$getValue());
        });

        // this.$updateValue = function(value, field) {

            // App.request('/encryption/decrypt', {value: value}).then(function(result) {
            //     console.log(result);
                // $this.value = result;
                // $this.$setValue(this.result);
                // $this.refs.input.value = result;
            // });

            // console.log(this.value);
            // this.value = value || '';
            // if (count > 0) {
            //     this.decryptValue(this.value);
            // }
            // this.update();
        // }.bind(this);

    </script>

</field-encrypt>