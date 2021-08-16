Vue.component('comments', {
    data() {
        return {
            form: {
                name: '',
                email: '',
                title: '',
                text: ''
            },
            checked: false,
            errors: {},
            comments: [],
            success: false
        }
    },

    methods: {
        async submit() {
            this.checked = false;
            this.errors = {};

            if (this.$refs.form.checkValidity() === false) {
                this.checked = true;
                return;
            }

            const formData = new FormData();
            Object.keys(this.form).forEach(key => formData.append(key, this.form[key]));

            let res = await axios.post('/', formData);

            if(res.data.status === 'error') {
                this.checked = true;
                this.errors = res.data.errors;
                return;
            }
            this.comments.unshift(res.data.comment);
            this.clearForm();
            this.success = true;
        },

        clearForm() {
            Object.keys(this.form).forEach(key => this.form[key] = '');
        }
    }
});

new Vue({
    el: '#app',
});
