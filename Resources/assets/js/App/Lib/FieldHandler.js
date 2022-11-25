export default {
    save: {
        handlers: {}
    },
    addSaveHandler: function (fieldType, callback) {
        if (!this.save.handlers[fieldType]) {
            this.save.handlers[fieldType] = [];
        }

        this.save.handlers[fieldType].push(callback);
    },
    executeSaveHandler: function (fieldType, htmlElement) {
        if (!this.save.handlers[fieldType]) {
            throw new Error('Save handler not found for ' + fieldType + ' field');
        }

        let content = '';

        this.save.handlers[fieldType].forEach((callback) => {
            content = callback(htmlElement);
        });

        return content;
    }
}
