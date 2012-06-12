import os, sys
from pyinotify import WatchManager, Notifier, ProcessEvent, EventsCodes
import pyinotify
def Monitor(path):
        class PDelete(ProcessEvent):
                def process_IN_ATTRIB(self,event):
                        f = event.name and os.path.join(event.path, event.name) or event.path
                        print 'got the event';
                        sys.exit(0)

        wm = WatchManager();
        notifier = Notifier(wm, PDelete());
        wm.add_watch(path, pyinotify.IN_ATTRIB);

        try:
                while 1:
                        notifier.process_events()
                        if notifier.check_events():
                                notifier.read_events()

        except KeyboardInterrupt:
                notifier.stop();
				
Monitor('events/'+sys.argv[1]);
