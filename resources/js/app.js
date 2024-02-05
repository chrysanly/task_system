// app.js
import './bootstrap';
import { createApp } from 'vue';
import FormComponent from './components/Form.vue';

const appElement = document.getElementById('app');
const userId = appElement ? appElement.dataset.userId : null;
const taskId = appElement ? appElement.dataset.taskId : null;
createApp(FormComponent, {
    taskId: taskId,
    userId: userId
}).mount("#app");

