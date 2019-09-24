export default {
    path: 'tasks',
    name: 'Tasks',
    component: () => import(/* webpackChunkName: "js/admin/tasks" */ './views/Tasks.vue'),
    redirect: { name: 'TasksList' },
    children: [
        {
            path: 'list',
            name: 'TasksList',
            component: () => import(/* webpackChunkName: "js/admin/tasks_list" */ './views/TasksList.vue')
        },
        {
            path: 'edit/:id',
            name: 'TasksForm',
            props: true,
            component: () => import(/* webpackChunkName: "js/admin/tasks_form" */ './views/TasksForm.vue')
        },
        {
            path: 'new',
            name: 'TasksNew',
            redirect: {
                name: 'TasksForm',
                params: { id: 0 }
            }
        }
    ]
}
