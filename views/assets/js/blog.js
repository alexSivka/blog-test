/**
 * component for comment form and comment list
 */
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

    async mounted() {
        this.getComments();
    },

    methods: {

        /**
         *
         * @param sortDirection
         * @returns {Promise<void>}
         */
        async getComments(sortDirection = 'desc') {
            let res = await axios.get('/getComments', {
                params: {
                    direction: sortDirection
                }
            });
            this.comments = res.data;
        },

        /**
         * @returns {Promise<void>}
         */
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

            setTimeout(() => this.success = false, 2000);
        },

        /**
         * clears comment form
         * returns void
         */
        clearForm() {
            Object.keys(this.form).forEach(key => this.form[key] = '');
        }
    }
});

new Vue({
    el: '#app',
});
