const apiAdafter = require("../../apiAdafter");
const { URL_SERVICE_USER } = process.env;

const api = apiAdafter(URL_SERVICE_USER);

module.exports = async (req, res) => {
  try {
    const user = await api.post("/users/register", req.body);
    return res.json(user.data);
  } catch (err) {
    if (err.code === "ECONNREFUSED") {
      return res
        .status(500)
        .json({ status: "error", message: "Service Unavailable" });
    }

    const { status, data } = err.response;
    return res.status(status).json(data);
  }
};
