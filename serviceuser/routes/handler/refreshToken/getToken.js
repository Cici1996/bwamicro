const { RefreshToken } = require("../../../models");

module.exports = async (req, res) => {
  const refresh_token = req.query.refresh_token;

  const token = await RefreshToken.findOne({
    where: {
      token: refresh_token,
    },
  });
  if (!token) {
    return res.status(404).json({
      status: "error",
      message: "Invalid Token",
    });
  }

  return res.json({
    status: "success",
    token,
  });
};
