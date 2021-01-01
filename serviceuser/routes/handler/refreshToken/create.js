const { User, RefreshToken } = require("../../../models");
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req, res) => {
  const user_id = req.body.user_id;
  const refresh_token = req.body.refresh_token;

  const schema = {
    refresh_token : 'string',
    user_id : 'number'
  };

  const validate = v.validate(req.body, schema);

  if (validate.length) {
    return res.status(400).json({ status: "error", message: validate });
  }

  const user = await User.findByPk(user_id);
  if (!user) {
    return res.status(404).json({
      status: "error",
      message: "user not found",
    });
  }

  const createRefreshToken = await RefreshToken.create({
      token:refresh_token,
      user_id:user_id
  })

  return res.json({
    status: "success",
    data: {
      id: createRefreshToken.id,
    },
  });
};
