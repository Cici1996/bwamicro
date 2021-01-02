const apiAdafter = require("../../apiAdafter");
const {
  URL_SERVICE_USER,
  JWT_SECRET,
  JWT_SECRET_REFRESH_TOKEN,
  JWT_ACCESS_TOKEN_EXPIRED,
} = process.env;
const jwt = require("jsonwebtoken");

const api = apiAdafter(URL_SERVICE_USER);

module.exports = async (req, res) => {
  try {
    const refreshToken = req.body.refresh_token;
    const email = req.body.email;

    if (!refreshToken && !email) {
      return res.status(404).json({
        status: "error",
        message: "Invalid Token",
      });
    }

    await api.get("/refresh_tokens", {
      params: {
        refresh_token: refreshToken,
      },
    });

    jwt.verify(refreshToken, JWT_SECRET_REFRESH_TOKEN, (err, decoded) => {
      if (err) {
        return res.status(403).json({
          status: "error",
          message: err.message,
        });
      }

      if (email !== decoded.data.email) {
        return res.status(400).json({
          status: "error",
          message: "Email Is Not Valid",
        });
      }

      const token = jwt.sign({ data: decoded.data }, JWT_SECRET, {
        expiresIn: JWT_ACCESS_TOKEN_EXPIRED,
      });

      return res.json({
        status: "success",
        data: {
          token,
        },
      });
    });
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
