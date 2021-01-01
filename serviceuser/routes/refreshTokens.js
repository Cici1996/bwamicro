const express = require("express");
const router = express.Router();
const refreshTokenHandler = require("./handler/refreshToken/");

router.post("/", refreshTokenHandler.create);
router.get("/", refreshTokenHandler.getToken);
router.post("/logout", refreshTokenHandler.logout);

module.exports = router;
