import Cookies from "js-cookie";
import Vue from "vue";
import router from "../../../router";
import {GET_LOGGED_USER, LOGIN_USER, LOGOUT_USER} from "./types";

export const doLogin = (context, { username, password }) => {
  const loginData = {
    email: username,
    password,
    grant_type: 'password',
    client_id: 2,
    client_secret: 'bwmQuioteK6cjzfAiPYfXNBhSWbx3qFEYcbXIx9F'
  };
  Vue.$axios.executeRequest("login", loginData, "post")
    .then(response => {
      Cookies.set("session_cookie", response.access_token);
      context.commit(LOGIN_USER, { meta: "SUCCESS" });
      router.push({ name: "Dashboard" });
      context.dispatch("getUser");
    })
    .catch(error => {
      if (error.status === 401) {
        context.dispatch(
          "messages/setFields",
          {
            username: error.body.message
          },
          { root: true }
        );
      }
      context.commit(LOGIN_USER, { meta: "ERROR" });
    });
};

export const getUser = ({ commit }) =>
  commit(GET_LOGGED_USER, Vue.$axios.get("profile"));

export const logout = ({ commit }) => {
  Cookies.remove("session_cookie");
  commit(LOGOUT_USER);
  router.push({ name: "Login" });
};
