const mongoose = require('mongoose');

let projectSchema = new mongoose.Schema(
  {
    title: {
      type: String,
      unique: false,
      required: true,
    },
    description: {
      type: String,
      unique: false,
      required: true,
    },
    technologies: {
      type: Array,
      unique: false,
      required: false,
    },
    repositories: {
      type: Array,
      unique: false,
      required: false,
    },
    images: {
      type: Array,
      unique: false,
      required: false,
    },
  },
  {
    timestamps: true,
  }
);

projectSchema.set('toJSON', {
  versionKey: false,
});

projectSchema.options.toJSON.transform = (doc, ret) => {
  ret.createdAt = new Date(ret.createdAt).toString();
  ret.updatedAt = new Date(ret.updatedAt).toString();

  let idObj = {id: ret._id};
  delete ret._id;

  return Object.assign({}, idObj, ret);
};

module.exports = mongoose.model('Project', projectSchema);
