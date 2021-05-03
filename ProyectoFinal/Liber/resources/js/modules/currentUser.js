const state = {
    user: {
        email: "prueba@gmail.com",
        name: "Nose"
    }
};
const getters = {};
const actions = {
    loginUser({ state, commit }, user) {
        //No funciona, da error 405
        /*axios.post("api/books", {
            author: user.name
        })
            .then(response => {
                console.log(response.data);
            })*/

        axios.get("api/books").then((response) => {
            response.data.forEach(u => {
                if (u.author == user.name) {
                    console.log(u);

                    state.user.name = u.author;

                    console.log("En el storage hay: " + state.user.name);

                    localStorage.setItem(
                        "book_title",
                        u.title
                    )

                    window.location.replace("/dhernandez/ProyectoFinal/Liber/public/")
                }
            });
        });
    }
};
const mutations = {};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}