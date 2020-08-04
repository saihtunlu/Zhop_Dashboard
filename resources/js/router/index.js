import Vue from "vue";
import VueRouter from "vue-router";
import Dashboard from "../views/dashboard/index.vue";

//User
import Users from "../views/user/index.vue";
import Add_User from "../views/user/create.vue";
import Edit_User from "../views/user/edit.vue";
import User from "../views/user/view.vue";

//Mail
import Mail from "../views/mail/index.vue";

//Todo
import Todo from "../views/todo/index.vue";

//Calendar
import Calendar from "../views/calendar/index.vue";

//settings
import Settings from "../views/settings/index.vue";

//Invoices
import Invoices from "../views/invoice/index.vue";
import Invoice from "../views/invoice/view.vue";
import Create_Invoice from "../views/invoice/create.vue";

//Product
import Products from "../views/product/index.vue";
import Add_Product from "../views/product/create.vue";
import Edit_Product from "../views/product/edit.vue";
import Product from "../views/product/view.vue";

//Brands
import Brands from "../views/Brands/index.vue";
import Add_Brand from "../views/Brands/create.vue";
// import Edit_Product from "../views/Brands/edit.vue";
// import Product from "../views/product/Brands.vue";

//Orders
import Orders from '../views/Order/index.vue'
import Order from '../views/Order/view.vue'

//event
import Events from '../views/event/index.vue'
//Shippings
import Shippings from "../views/shipping/index.vue";
import Add_Shipping from "../views/shipping/create.vue";
import Test_Shipping from "../views/shipping/test.vue";
import Shipping from "../views/shipping/view.vue";


//Payments
import Payments from "../views/payment/index.vue";
import Add_Payment from "../views/payment/create.vue";
import Test_Payment from "../views/payment/test.vue";
import Payment from "../views/payment/view.vue";


//Categories
import Categories from "../views/category/index.vue";
import Add_Category from "../views/category/create.vue";

//Auth
import SignIn from "../views/auth/signIn.vue";
import Reset from "../views/auth/reset.vue";
import Activate from "../views/auth/activation.vue";





Vue.use(VueRouter);

const routes = [{
    path: "/signIn", //Start Auth
    name: "SignIn",
    component: SignIn,
    meta: { requiresVisitor: true }
},
{
    path: "/reset_password/:token",
    name: "Reset",
    component: Reset,
    meta: { requiresVisitor: true }
},
{
    path: "/activation/:token",
    name: "Activate",
    component: Activate,
    meta: { requiresVisitor: true }
},
{
    path: "/mail",
    name: "Mail",
    component: Mail,
    meta: { requiresAuth: true, index: 11 }
},
{
    path: "/todo",
    name: "Todo",
    component: Todo,
    meta: { requiresAuth: true, index: 12 }
},
{
    path: "/calendar",
    name: "Calendar",
    component: Calendar,
    meta: { requiresAuth: true, index: 13 }
},
{
    path: "/",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true, index: 1 }
},
{
    path: "/users", //Starting of User
    name: "Users",
    component: Users,
    meta: { requiresAuth: true, index: 2 }
},
{
    path: "/add_user",
    name: "Add_User",
    component: Add_User,
    meta: { requiresAuth: true, index: 2 }
},
{
    path: "/user/:id",
    name: "User",
    component: User,
    meta: { requiresAuth: true, index: 2 }
},
{
    path: "/products", //Starting of User
    name: "Products",
    component: Products,
    meta: { requiresAuth: true, index: 3 }
},
{
    path: "/add_product",
    name: "Add_Product",
    component: Add_Product,
    meta: { requiresAuth: true, index: 3 }
},
{
    path: "/edit_product/:id",
    name: "Edit_Product",
    component: Edit_Product,
    meta: { requiresAuth: true, index: 3 }
},
{
    path: "/product/:id",
    name: "Product",
    component: Product,
    meta: { requiresAuth: true, index: 3 }
},
{
    path: "/orders", //Starting of User
    name: "Orders",
    component: Orders,
    meta: { requiresAuth: true, index: 8 }
},
{
    path: "/order/:id", //Starting of User
    name: "Order",
    component: Order,
    meta: { requiresAuth: true, index: 8 }
},
{
    path: "/events", //Starting of User
    name: "Events",
    component: Events,
    meta: { requiresAuth: true, index: 9 }
},
{
    path: "/brands", //Starting of User
    name: "Brands",
    component: Brands,
    meta: { requiresAuth: true, index: 4 }
},
{
    path: "/add_brand",
    name: "Add_Brand",
    component: Add_Brand,
    meta: { requiresAuth: true, index: 4 }
},
{
    path: "/shippings", //Starting of Shippings
    name: "Shippings",
    component: Shippings,
    meta: { requiresAuth: true, index: 6 }
},
{
    path: "/shipping/:id",
    name: "Shipping",
    component: Shipping,
    meta: { requiresAuth: true, index: 6 }
},
{
    path: "/add_shipping",
    name: "Add_Shipping",
    component: Add_Shipping,
    meta: { requiresAuth: true, index: 6 }
},
{
    path: "/test_shipping",
    name: "Test_Shipping",
    component: Test_Shipping,
    meta: { requiresAuth: true, index: 6 }
},
{
    path: "/payments", //Starting of Payments
    name: "Payments",
    component: Payments,
    meta: { requiresAuth: true, index: 7 }
},
{
    path: "/payment/:id", //Starting of Payments
    name: "Payment",
    component: Payment,
    meta: { requiresAuth: true, index: 7 }
},
{
    path: "/add_payment", //Starting of Payments
    name: "Add_Payment",
    component: Add_Payment,
    meta: { requiresAuth: true, index: 7 }
},
{
    path: "/test_payment", //Starting of Payments
    name: "Test_Payment",
    component: Test_Payment,
    meta: { requiresAuth: true, index: 7 }
},
{
    path: "/categories", //Starting of categories
    name: "Categories",
    component: Categories,
    meta: { requiresAuth: true, index: 5 }
},
{
    path: "/add_category",
    name: "Add_Category",
    component: Add_Category,
    meta: { requiresAuth: true, index: 5 }
},


{
    path: "/invoices", //Starting of invoices
    name: "Invoices",
    component: Invoices,
    meta: { requiresAuth: true, index: 10 }
},
{
    path: "/invoice",
    name: "Invoice",
    component: Invoice,
    meta: { requiresAuth: true, index: 10 }
}, {
    path: "/create_invoice", //Starting of invoices
    name: "Create_Invoice",
    component: Create_Invoice,
    meta: { requiresAuth: true, index: 10 }
},
{
    path: "/settings", //Starting of settings
    name: "Settings",
    component: Settings,
    meta: { requiresAuth: true, index: 14 }
},

];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

function isLoggedIn() {
    return localStorage.getItem("isLoggedIn");
}

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!isLoggedIn()) {
            next({
                name: "SignIn"
            });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (isLoggedIn()) {
            next({
                name: "Dashboard"
            });
        } else {
            next();
        }
    } else {
        next(); // make sure to always call next()!
    }
});

export default router;