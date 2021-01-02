const express = require("express");
const router = express.Router();

const userHandler = require("./handler/user");
const verifyToken = require("./../middlewares/verifyToken");

router.post("/register", userHandler.register);
router.post("/login", userHandler.login);
router.post("/logout",verifyToken, userHandler.logout);
router.put("/",verifyToken, userHandler.update);
router.get("/", verifyToken, userHandler.getUser);

module.exports = router;
