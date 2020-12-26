"use strict";
const bcrypt = require("bcrypt");

module.exports = {
  up: async (queryInterface, Sequelize) => {
    await queryInterface.bulkInsert(
      "users",
      [
        {
          name: "Administartor",
          profession: "Administartor",
          role: "admin",
          email: "admin@admin.com",
          password: await bcrypt.hash("default", 10),
          created_at: new Date(),
          updated_at: new Date(),
        },
        {
          name: "Student",
          profession: "Student",
          role: "student",
          email: "student@admin.com",
          password: await bcrypt.hash("default", 10),
          created_at: new Date(),
          updated_at: new Date(),
        },
      ],
      {}
    );
  },

  down: async (queryInterface, Sequelize) => {
    await queryInterface.bulkDelete('users', null, {});
  },
};
