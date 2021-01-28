export const actionColumnMixin = {
    methods: {
        _addActionColumn() {
            if (this.allowActions.all) {
                this.fields.push({
                    key:   'actions',
                    label: 'Aktionen',
                });
            }
        },
    }
}
