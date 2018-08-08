<field-encrypt>

    <input ref="input" class="uk-width-1-1" bind="{opts.bind}" type="text">

    <script>

        var $this = this;

        decryptValue(value) {
            $.get('/encryption/decrypt', { value: value }, function(result, status){
                $this.$setValue(result);
            });
        }

        this.on('mount', function() {
            this.value = this.decryptValue(this.$getValue());

            this.update();
        });

        this.$updateValue = function(value, field) {
            this.value = value;
            this.update();
        }.bind(this);

    </script>

</field-encrypt>