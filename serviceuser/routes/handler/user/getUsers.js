const { User } = require("../../../models");
module.exports = async (req, res) => {
  const userIds = req.query.ids || [];

  const sqlOption = {
    attributes: ["id", "name", "email", "profession", "avatar"],
  };

  if (userIds.length) {
    sqlOption.where = {
      id: userIds,
    };
  }

  const user = await User.findAll(sqlOption);

  return res.json({
    status: "success",
    data: user,
  });
};
