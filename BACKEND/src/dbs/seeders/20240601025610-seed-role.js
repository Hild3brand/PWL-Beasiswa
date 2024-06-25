'use strict';

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up (queryInterface, Sequelize) {
    await queryInterface.bulkInsert(
      'roles',
      [
        {
          nama_role: 'Admin',
          createdAt: new Date(),
          updatedAt: new Date(),
        },
        {
          nama_role: 'Fakultas',
          createdAt: new Date(),
          updatedAt: new Date(),
        },
        {
          nama_role: 'Program Studi',
          createdAt: new Date(),
          updatedAt: new Date(),
        },
        {
          nama_role: 'Mahasiswa',
          createdAt: new Date(),
          updatedAt: new Date(),
        },
      ],
      {}
    );
  },

  async down (queryInterface, Sequelize) {
    await queryInterface.bulkDelete('role', null, {});
  }
};
