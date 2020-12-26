const axios = require("axios");
const {TIMEOUT} = process.env;

module.exports = (baseurl) => {
    return axios.create({
        baseURL : baseurl,
        timeout  : parseInt(TIMEOUT)
    })
}