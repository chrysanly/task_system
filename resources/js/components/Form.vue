<template>

    <div v-if="success" class="alert alert-success" role="alert">
            Success
        </div>
    <form @submit.prevent="submitForm">
        <div class="mb-3">
            <label for="" class="form-label">Description</label>
            <textarea
                v-model="formData.description"
                class="form-control"
                id="description"
                name="description"
                rows="3"
            >{{ formData.description }}</textarea>
        </div>

        <div class="display-none" v-if="!success">
            <button class="btn btn-primary" type="submit">{{ isUpdating ? "Update" : "Submit" }}</button>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        task: {
            type: Object,
            default: () => ({ description: "" }),
        },
        taskId: {
            type: String,
            default: null,
        },
        userId: {
            type: String,
            default: null,
        }
    },
    data() {
        return {
            formData: {
                description: this.taskId ? this.task.description : null,
                userId: this.userId,
                taskId: this.taskId,
            },
            success: false,
        };
    },
    computed: {
        isUpdating() {
            return !!this.taskId; // Assuming tasks have an 'id' field for identification
        },
    },
    mounted() {
        // Fetch task by taskId if it exists
        if (this.isUpdating) {
            this.fetchTask();
        }
    },
    methods: {
        fetchTask() {
            // console.log(`/api/tasks/edit/${this.taskId}`);
            // Assuming you are using Axios for HTTP requests
            axios.get(`/api/tasks/edit/${this.taskId}`)
                .then((response) => {
                    // Update formData with the fetched task data
                    this.formData.description = response.data.description;
                })
                .catch((error) => {
                    console.error(`Error fetching task:`, error);
                });
        },
        submitForm() {
            const endpoint = this.isUpdating
                ? `/api/tasks/update/${this.taskId}`
                : "/api/tasks/store";
            // Assuming you are using Axios for HTTP requests
            axios[this.isUpdating ? "patch" : "post"](endpoint, this.formData)
                .then((response) => {
                    console.log(
                        `Task ${this.isUpdating ? "Updated" : "Created"}:`,
                        response.data
                    );
                    this.success = true;
                    window.location.href = response.data.redirect;
                })
                .catch((error) => {
                    console.error(
                        `Error ${
                            this.isUpdating ? "updating" : "creating"
                        } task:`,
                        error
                    );
                });
        },
    },
};
</script>
