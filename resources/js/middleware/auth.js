// Check if the """cookie""" is set
// TODO: Check if the token is still valid
export default function auth({ next, router }) {
    if (localStorage.getItem("apiToken") === null) {
        return router.push({ name: "login" });
    }

    return next();
}