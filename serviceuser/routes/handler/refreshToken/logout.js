const { User, RefreshToken } = require("../../../models");

module.exports = async (req, res) => {
  const user_id = req.body.user_id;

  const user = await User.findByPk(user_id);

  if (!user) {
    return res.status(404).json({
      status: "error",
      message: "user not found",
    });
  }

  await RefreshToken.destroy({
    where: {
      user_id: user_id,
    },
  });

  return res.json({
    status: "success",
    message: "Refresh Token Deleted",
  });
};
