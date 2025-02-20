const Ziggy = {"url":"http:\/\/localhost:3333\/message\/text","port":3333,"defaults":{},"routes":{"login":{"uri":"\/","methods":["GET","HEAD"]},"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"clients":{"uri":"clients","methods":["GET","HEAD"]},"clients.create":{"uri":"clients\/create","methods":["GET","HEAD"]},"clients.edit":{"uri":"clients\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"]},"messages.index":{"uri":"messages","methods":["GET","HEAD"]},"messages.store":{"uri":"messages","methods":["POST"]},"messages.send":{"uri":"send-messages","methods":["POST"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
